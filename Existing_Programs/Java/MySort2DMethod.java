import java.util.*;
public class MySort2DMethod
{
	int i, j, k, row, col;
	int arr[][]= new int[10][10];
	int sort[]= new int[100];
	Scanner sc= new Scanner(System.in);
	MySort2DMethod()
	{
		i=0;
		j=0;
		k=0;
		row=0;
		col=0;
	}
	void getVal()
	{
		System.out.println("Enter Number of Row & Column : ");
		row=sc.nextInt();
		col=sc.nextInt();
		for(i=0;i<row;i++)
		{
			for(j=0;j<col;j++)
			{
				System.out.println("Enter Value : ");
				arr[i][j]=sc.nextInt();
				sort[k++]=arr[i][j];
			}
		}
	}
	void putVal()
	{
		for(i=0;i<row;i++)
		{
			for(j=0;j<col;j++)
			{
				System.out.print(arr[i][j]+"\t");
			}
			System.out.println();
		}
	}
	void sort()
	{
		for(int i=0; i<row*col; i++)
		{
			for(j=0;j<(row*col)-i-1;j++)
			{
				if(sort[j]>sort[j+1])
				{
					int temp=sort[j];
					sort[j]=sort[j+1];
					sort[j+1]=temp;
				}
			}
		}
		k=0;
		for(i=0;i<row;i++)
		{
			for(j=0;j<col;j++)
			{
				arr[i][j]=sort[k++];
			}
		}
		
	}
	public static void main(String args[])
	{
		MySort2DMethod obj=new MySort2DMethod();
		obj.getVal();
		System.out.println("Unsorted Matrix : ");
		obj.putVal();	
		System.out.println("Sorted Matrix : ");
		obj.sort();
		obj.putVal();
	}
}
